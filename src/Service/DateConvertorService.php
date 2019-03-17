<?php

namespace App\Service;


class DateConvertorService
{
    /**
     * @param $rawDate
     * @return \DateTime|false|int|string|string[]|null
     * @throws \Exception
     */
    public function convertDate($rawDate)
    {
        // catch month in $month var
        preg_match('/\-(.*)\./', $rawDate, $month);
        $month = $month[1];

        // convert month format from data
        switch ($month) {
            case "janv":
                $month = 'jan';
                break;
            case "fév":
                $month = 'feb';
                break;
            case "avr":
                $month = 'apr';
                break;
            case "mai":
                $month= 'may';
                break;
            case "jui":
                $month = 'jun';
                break;
            case "aoû":
                $month = 'aug';
                break;
            case "aou":
                $month = 'aug';
                break;
            case "déc":
                $month = 'dec';
                break;
        }

        $date = preg_replace('/(\d*\-)(.*)(\.\-\d*)/', '$1'.$month.'$3', $rawDate);
        $date = strtotime($date);
        $date = new \DateTime("@$date");

        return $date;
    }
}
