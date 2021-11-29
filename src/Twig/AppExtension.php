<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

use App\Entity\Article;
class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('filter_name', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('pluralizes', [$this, 'pluralize']),
            new TwigFunction('checkPromos', [$this, 'checkPromotion']),
            new TwigFunction('promotionPrice', [$this, 'promotionPrice']),
            new TwigFunction('calculateTotalPrice', [$this, 'calculateTotalPrice']),
        ];
    }

    public function pluralize(int $nb_article, string $title)
    {

        return $nb_article > 1 ? $title.'s' : $title;
    }

    public function checkPromotion(Article $article, $promos)
    {
        foreach ( $promos as $promo) {
            if ( $article === $promo->getArticle() ) {

                return $promo->getvalue();
            }
        }

        return null;
    }

    public function promotionPrice(Article $article, $promos)
    {
        foreach ( $promos as $promo) {
            if ( $article === $promo->getArticle() ) {

               $value = ( $article->getUnitPrice() * $promo->getValue() ) / 100;
               
               return $article->getUnitPrice() - $value;
            }
        }

        return null;
    }
}
