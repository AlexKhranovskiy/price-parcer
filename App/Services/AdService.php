<?php

namespace App\Services;

class AdService
{
    protected string|bool $source;
    public function getSource(string $url): static
    {
        $this->source = file_get_contents($url);
        if($this->source === false){
            throw new \Exception('Valid response from remote service has not been got.');
        }
        return $this;
    }
    public function getPriceAndCurrencyCode(): bool|array
    {
        $pattern = '/regularPrice' . '\\' . '\"' . ':{' . '\\' . '\"value' . '\\' . '\"' . ':(\d+)' . ',\\' .'\"currencyCode' . '\\' .'\":'. '\\' . '\"' . '([A-Z]+)' . '/';
        preg_match($pattern, $this->source,$out);
        if(sizeof($out) > 0){
            return ['price' => $out[1], 'currencyCode' => $out[2]];
        } else {
            throw new \Exception('Failed getting price and currency code from remote service.');
        }
    }

    public function handle($url)
    {
        $s = $this->getSource($url);
        return $s->getPrice();

    }
}