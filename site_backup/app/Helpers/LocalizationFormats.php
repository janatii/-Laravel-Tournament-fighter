<?php

namespace App\Helpers;

use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Translation\Translator;

class LocalizationFormats
{
    /**
     * @var Translator
     */
    protected $translator;
    
    /**
     * @var ConfigRepository
     */
    protected $config;
    
    public function __construct(Translator $translator, ConfigRepository $config)
    {
        $this->translator = $translator;
        $this->config = $config;
    }
    
    public function getAllFormats()
    {
        return $this->config->get("localization.formats.{$this->translator->getLocale()}") + $this->config->get("localization.formats.{$this->translator->getFallback()}");
    }
    
    public function getFormat($type, $language = 'php')
    {
        return $this->config->get("localization.formats.{$this->translator->getLocale()}.{$type}.{$language}",
            $this->config->get("localization.formats.{$this->translator->getFallback()}.{$type}.{$language}")
        );
    }
    
    public function getAcceptedLocales()
    {
        return (array)json_decode(config('app.locales'));
    }
    
    public function formatMoney($money)
    {
        if ($this->translator->getLocale() == 'en') {
            return '€ ' . $money;
        } else {
            return str_replace('.', ',', $money) . ' €';
        }
    }
}
