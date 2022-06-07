<?php
namespace App\Helper;
use Carbon\Carbon;

class MyHelper{
    public static function toastNotification($replaceValue = [])
	{
		$notification = [
	        'success' => true,
	        'heading' => 'Success',
	        'text' => 'Not Setting',
	        'showHideTransition' => true,
	        'icon' => 'success',
	        'position' => 'top-end',
	        'data' => null,
		];

		return array_replace($notification, $replaceValue);
	}

	public static function getYear($range = 30)
    {
        $rangeYears = range(Carbon::now()->year, Carbon::now()->year - $range);
		$years = [];
		$years[] = ['id' => '', 'text' => ''];

        foreach($rangeYears as $data)
        {
            $years[] = ['id' => $data, 'text' => $data];
        }

        return $years;
    }

    public static function numberToRoman($number) {
        $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
        $returnValue = '';
        while ($number > 0) {
            foreach ($map as $roman => $int) {
                if($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }

    public static function monthFullFormat($month)
    {
        $bulan = [
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];

        return $bulan[$month];
    }

    public static function formatDate($date = '', $format = ''){
        if($date == '' || $date == null)
            return;

        return date($format,strtotime($date));
    }
}
