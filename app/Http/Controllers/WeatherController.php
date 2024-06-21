<?php

namespace App\Http\Controllers;

use App\Models\Weather;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WeatherController extends Controller
{

    public function getWeatherDataApi()
    {
        $weatherData = Weather::orderBy('base_time', 'asc')->get();
        return response()->json($weatherData);
    }

    public function getWeatherData()
    {
        // 한국 시간으로 설정
        $currentTime = Carbon::now()->setTimezone('Asia/Seoul');

        // 현재 시간을 기준으로 정시로 맞추기 (API 호출용)
        $baseTimeForApi = $currentTime->copy()->minute(0)->second(0)->format('H00');
        // 현재 시간을 기준으로 정시로 맞추기 (DB 저장용)
        $baseTimeForDb = $currentTime->copy()->minute(0)->second(0)->format('H:i:s');
        $baseDate = $currentTime->format('Ymd');

        // API 호출 함수
        $data = $this->fetchWeatherData($baseDate, $baseTimeForApi);

        // 유효한 데이터가 있는지 확인
        $t1hValue = null;
        $rehValue = null;
        foreach ($data['response']['body']['items']['item'] as $item) {
            if ($item['category'] === 'T1H') {
                $t1hValue = $item['obsrValue'];
            } elseif ($item['category'] === 'REH') {
                $rehValue = $item['obsrValue'];
            }
        }

        // 유효한 데이터가 없으면 한 시간 전 데이터 가져오기
        if ($t1hValue === null || $rehValue === null) {
            $previousHour = $currentTime->copy()->subHour();
            $baseTimeForApi = $previousHour->minute(0)->second(0)->format('H00');
            $baseTimeForDb = $previousHour->minute(0)->second(0)->format('H:i:s');
            $baseDate = $previousHour->format('Ymd');

            $data = $this->fetchWeatherData($baseDate, $baseTimeForApi);

            foreach ($data['response']['body']['items']['item'] as $item) {
                if ($item['category'] === 'T1H') {
                    $t1hValue = $item['obsrValue'];
                } elseif ($item['category'] === 'REH') {
                    $rehValue = $item['obsrValue'];
                }
            }
        }

        // Save to database
        Weather::create([
            'temperature' => $t1hValue,
            'humidity' => $rehValue,
            'base_date' => $baseDate,
            'base_time' => $baseTimeForDb,
        ]);

        return view('weather', [
            't1hValue' => $t1hValue,
            'rehValue' => $rehValue,
            'baseDate' => $baseDate,
            'baseTime' => $baseTimeForDb,
        ]);
    }

    private function fetchWeatherData($baseDate, $baseTime)
    {
        $ch = curl_init();
        $url = 'http://apis.data.go.kr/1360000/VilageFcstInfoService_2.0/getUltraSrtNcst'; /*URL*/
        $queryParams = '?' . urlencode('serviceKey') . '=axqbCgWHznH2tpVTBE8ZOvabiNvweh5E62C8oKOCWThcM9JguxembRtoaVUOXha0Kcm1E04PmR%2BNbsLpvdgeyQ%3D%3D'; /*Service Key*/
        $queryParams .= '&' . urlencode('pageNo') . '=' . urlencode('1'); /**/
        $queryParams .= '&' . urlencode('numOfRows') . '=' . urlencode('1000'); /**/
        $queryParams .= '&' . urlencode('dataType') . '=' . urlencode('JSON'); /**/
        $queryParams .= '&' . urlencode('base_date') . '=' . urlencode($baseDate);
        $queryParams .= '&' . urlencode('base_time') . '=' . urlencode($baseTime);
        $queryParams .= '&' . urlencode('nx') . '=' . urlencode('55'); /**/
        $queryParams .= '&' . urlencode('ny') . '=' . urlencode('127'); /**/

        curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
}