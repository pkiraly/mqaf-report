<?php

// modified version of https://stackoverflow.com/questions/19249159/best-practice-multi-language-website
class DdbLocale {

  protected $translation = array();
  protected $locale;
  protected $default_locale = 'de';
  protected $locale_dir = 'locale';

  public function __construct($locale) {
    $this->locale = $locale;
    $this->init();
    $this->loadTranslation($this->locale);
  }

  public function getLocale() {
    return $this->locale;
  }

  /**
   * Determine if transltion exist or translation key exist
   *
   * @param string $locale
   * @param string $key
   * @return boolean
   */
  public function hasTranslation($key = null) {
    if (null == $key && isset($this->translation[$this->locale])) {
      return true;
    } elseif (isset($this->translation[$this->locale][$key])) {
      return true;
    }
    return false;
  }

  /**
   * Get the transltion for required locale or transtion for key
   *
   * @param string $locale
   * @param string $key
   * @return array
   */
  public function getTranslation($key = null) {
    if (null == $key && $this->hasTranslation($this->locale)) {
      return $this->translation[$this->locale];
    } elseif ($this->hasTranslation($key)) {
      return $this->translation[$this->locale][$key];
    }

    return array();
  }

  /**
   * Set the transtion for required locale
   *
   * @param string $locale
   *            Language code
   * @param string $trans
   *            translations array
   */
  public function setTranslation($locale, $trans = array()) {
    $this->translation[$locale] = $trans;
  }

  /**
   * Initialize locale
   *
   * @param string $locale
   */
  public function init($locale = null, $default_locale = null) {
    // check if previously set locale exist or not
    $this->init_locale();
    if ($this->locale != null) {
      return;
    }

    if ($locale == null
       || (! preg_match('#^[a-z]+_[a-zA-Z_]+$#', $locale)
             && ! preg_match('#^[a-z]+_[a-zA-Z]+_[a-zA-Z_]+$#', $locale))) {
      $this->detectLocale();
    } else {
      $this->locale = $locale;
    }

    $this->init_locale();
  }

  /**
   * Check if config for selected locale exists
   *
   * @return void
   */
  private function init_locale() {
    if (! file_exists(sprintf('%s/locale.%s.ini', $this->locale_dir, $this->locale))) {
      $this->locale = $this->default_locale;
    }
  }

  /**
   * Load a Transtion into array
   *
   * @return void
   */
  private function loadTranslation($locale = null, $force = false) {
    if ($locale == null)
      $locale = $this->locale;

    if (! isset($this->translation[$locale])) {
      $file = sprintf("locale/locale.%s.ini", $locale);
      $entries = parse_ini_file($file, false, INI_SCANNER_RAW);
      $this->setTranslation($locale, $entries);
    }
  }

  /**
   * Translate a key
   *
   * @param
   *            string Key to be translated
   * @param
   *            string optional arguments
   * @return string
   */
  public function translate($key) {

    if (! $this->hasTranslation($key)) {
      if ($this->locale !== $this->default_locale) {
        $this->loadTranslation($this->default_locale);
        if ($this->hasTranslation($this->default_locale, $key)) {
          $translation = $this->getTranslation($key);
        } else {
          // return key as it is or log error here
          return $key;
        }
      } else {
        return $key;
      }
    } else {
      $translation = $this->getTranslation($key);
    }

    // Replace arguments
    if (false !== strpos($translation, '{a:')) {
      $replace = array();
      $args = func_get_args()[1];
      array_unshift($args, '');
      for ($i = 1, $max = count($args); $i < $max; $i++) {
        $replace['{a:' . $i . '}'] = $args[$i];
      }
      // interpolate replacement values into the messsage then return
      return strtr($translation, $replace);
    }

    return $translation;
  }
}