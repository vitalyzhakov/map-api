<?php

namespace app\models\traits;

trait Seasonal {
    /**
     * Текущий сезон
     * @return string
     */
    private function getCurrentSeason() {
        $month = date('n');
        $season = null;
        switch ($month) {
            case 11:
            case 12:
            case 1:
            case 2:
            case 3:
                $season = 'winter';
                break;
            case 4:
            case 5:
                $season = 'spring';
                break;
            case 6:
            case 7:
            case 8:
                $season = 'summer';
                break;
            case 9:
            case 10:
                $season = 'autumn';
                break;
        }
        return $season;
    }

    /**
     * Текущий ли сезон
     * @return boolean
     */
    public function isCurrentSeason() {
        return $this->seasonal === $this->getCurrentSeason();
    }
}

