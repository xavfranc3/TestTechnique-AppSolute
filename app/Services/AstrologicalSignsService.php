<?php

namespace App\Services;

class AstrologicalSignsService {

    public function getChineseSign($dobString): string
    {
        $splitDate = $this->splitDate($dobString);
        $chineseSignsArray = array('Monkey', 'Rooster', 'Dog', 'Pig', 'Rat', 'Ox', 'Tiger', 'Rabbit', 'Dragon', 'Snake', 'Horse', 'Goat');
        return $chineseSignsArray[$splitDate[0] % 12];
    }

    public function getZodiacSign($dobString): string
    {
        $splitDate = $this->splitDate($dobString);
        $zodiac = array('', 'Capricorn', 'Aquarius', 'Pisces', 'Aries', 'Taurus', 'Gemini', 'Cancer', 'Leo', 'Virgo', 'Libra', 'Scorpio', 'Sagittarius', 'Capricorn');
        $lastDay = array('', 19, 18, 20, 20, 21, 21, 22, 22, 21, 22, 21, 20, 19);
        return ($splitDate[2] > $lastDay[$splitDate[1]]) ? $zodiac[$splitDate[1] + 1] : $zodiac[$splitDate[1]];
    }

//    Date format is 'yyyy-mm-dd'
    private function splitDate($dobString): array {
        return array_map('intval', explode('-', $dobString));
    }
}
