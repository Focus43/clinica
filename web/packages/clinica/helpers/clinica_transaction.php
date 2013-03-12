<?php

	class ClinicaTransactionHelper {
		
		/**
		 * Helper to easily render list of available card types
		 */
		public static $cardTypes = array(
			''				=> 'Type',
			'visa' 			=> 'Visa',
			'mastercard'	=> 'Mastercard'
		);
		
		
		/**
		 * Helper to render expiration months
		 */
		public static function expiryMonths(){
			$months = array_combine(range(1,12),range(1,12));
			return (array('' => 'Month') + $months);
		}
		
		
		/**
		 * Helpers for expiration years
		 */
		public static function expiryYears(){
			$curYear = (int) date('Y');
			$inEight = $curYear + 8;
			$years = array_combine(range($curYear, $inEight),range($curYear, $inEight));
			return (array('' => 'Year') + $years);
		}
		
		
		public static function typeHandles(){
			return (array('' => 'Type') + array(
				ClinicaTransaction::TYPE_BILL_PAY 	=> 'Bill Payment',
				ClinicaTransaction::TYPE_DONATION 	=> 'Donation',
				ClinicaTransaction::TYPE_MISS_GREEK	=> 'Miss Greek'
			));
		}
		
	}
