<?php

namespace App\Data;

class SearchData {

	/**
	 * 
	 * @var String
	 */ 
	public $q = "";

	/**
	 * 
	 * @var category[] 
	 */ 
	public $categories = [];

	/**
	 * 
	 * @var null|integer
	 * 
	 */ 
	public $min_price;

	/**
	 * 
	 * @var null|integer
	 * 
	 */
	public $max_price;

	/**
	 * 
	 * @var boolean
	 * 
	 */
	public $promo = false;
}