<?php

namespace App\Service;

use App\Entity\Article;

class Helper 
{

	public function getPromotionPrice(Article $article,  array $promos)
	{
		foreach ( $promos as $promo) {
            if ( $article === $promo->getArticle() ) {
                $value = ( $article->getUnitPrice() * $promo->getValue() ) / 100;
                return $article->getUnitPrice() - $value;
            }
            else{
            	return $article->getUnitPrice();
            }
        }

	}
}