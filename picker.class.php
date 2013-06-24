<?php
namespace lowtone\google\picker;
use lowtone\db\records\Record,
	lowtone\db\records\schemata\properties\types\Enum;

/**
 * @author Paul van der Meijs <code@lowtone.nl>
 * @copyright Copyright (c) 2013, Paul van der Meijs
 * @license http://wordpress.lowtone.nl/license/
 * @version 1.0
 * @package wordpress\libs\lowtone\google\picker
 */
class Picker extends Record {
	
	const PROPERTY_ID = "picker_id",
		PROPERTY_VIEWS = "views",
		PROPERTY_CALLBACK = "callback";

	const VIEW_DOCS = "DOCS",
		VIEW_DOCS_IMAGES = "DOCS_IMAGES",
		VIEW_DOCS_IMAGES_AND_VIDEOS = "DOCS_IMAGES_AND_VIDEOS",
		VIEW_DOCS_VIDEOS = "DOCS_VIDEOS",
		VIEW_DOCUMENTS = "DOCUMENTS",
		VIEW_FOLDERS = "FOLDERS",
		VIEW_FORMS = "FORMS",
		VIEW_IMAGE_SEARCH = "IMAGE_SEARCH",
		VIEW_MAPS = "MAPS",
		VIEW_PDFS = "PDFS",
		VIEW_PHOTO_ALBUMS = "PHOTO_ALBUMS",
		VIEW_PHOTO_UPLOAD = "PHOTO_UPLOAD",
		VIEW_PHOTOS = "PHOTOS",
		VIEW_PRESENTATIONS = "PRESENTATIONS",
		VIEW_RECENTLY_PICKED = "RECENTLY_PICKED",
		VIEW_SPREADSHEETS = "SPREADSHEETS",
		VIEW_VIDEO_SEARCH = "VIDEO_SEARCH",
		VIEW_WEBCAM = "WEBCAM",
		VIEW_YOUTUBE = "YOUTUBE";

	const LANG_AF = "af",
		LANG_AM = "am",
		LANG_AR = "ar",
		LANG_BG = "bg",
		LANG_BN = "bn",
		LANG_CA = "ca",
		LANG_CS = "cs",
		LANG_DA = "da",
		LANG_DE = "de",
		LANG_EL = "el",
		LANG_EN = "en",
		LANG_EN_GB = "en-GB",
		LANG_ES = "es",
		LANG_ES_419 = "es-419",
		LANG_ET = "et",
		LANG_EU = "eu",
		LANG_FA = "fa",
		LANG_FI = "fi",
		LANG_FIL = "fil",
		LANG_FR = "fr",
		LANG_FR_CA = "fr-CA",
		LANG_GL = "gl",
		LANG_GU = "gu",
		LANG_HI = "hi",
		LANG_HR = "hr",
		LANG_HU = "hu",
		LANG_ID = "id",
		LANG_IS = "is",
		LANG_IT = "it",
		LANG_IW = "iw",
		LANG_JA = "ja",
		LANG_KN = "kn",
		LANG_KO = "ko",
		LANG_LT = "lt",
		LANG_LV = "lv",
		LANG_ML = "ml",
		LANG_MR = "mr",
		LANG_MS = "ms",
		LANG_NL = "nl",
		LANG_NO = "no",
		LANG_PL = "pl",
		LANG_PT_BR = "pt-BR",
		LANG_PT_PT = "pt-PT",
		LANG_RO = "ro",
		LANG_RU = "ru",
		LANG_SK = "sk",
		LANG_SL = "sl",
		LANG_SR = "sr",
		LANG_SV = "sv",
		LANG_SW = "sw",
		LANG_TA = "ta",
		LANG_TE = "te",
		LANG_TH = "th",
		LANG_TR = "tr",
		LANG_UK = "uk",
		LANG_UR = "ur",
		LANG_VI = "vi",
		LANG_ZH_CN = "zh-CN",
		LANG_ZH_HK = "zh-HK",
		LANG_ZH_TW = "zh-TW",
		LANG_ZU = "zu";

	public function __construct($input = NULL, $flags = 0, $iterator_class = "ArrayIterator") {
		parent::__construct($input, $flags, $iterator_class);

		add_action("wp_ajax_lowtone_google_picker_" . $this->{self::PROPERTY_ID}, array($this, "doCallback"));
	}

	public function doCallback() {
		if (is_callable($callback = $this->{self::PROPERTY_CALLBACK}))
			call_user_func($callback);
	}

	public function button($options = NULL) {
		$options = array_merge(array(
				"text" => __("Select a file", "lowtone_google_picker"),
				"class" => "button button-primary",
			), (array) $options);

		$pickerId = "lowtone_google_picker_" . $this->{self::PROPERTY_ID};

		wp_enqueue_script("lowtone_google_picker", LIB_URL . "/lowtone-google-picker/assets/scripts/jquery.google-picker.js", array("jquery", "google-jsapi"));
		wp_localize_script("lowtone_google_picker", "lowtone_google_picker", array(
				"ajaxurl" => admin_url("admin-ajax.php"),
				"language" => reset(explode("_", get_locale())),
			));

		$pickerOptions = array_intersect_key((array) $this, array_flip(array(self::PROPERTY_ID, self::PROPERTY_VIEWS)));

		return sprintf(
				'<button id="%s" class="lowtone google picker %s" data-picker="%s">%s</button>', 
				esc_attr($pickerId), 
				esc_attr(implode(" ", (array) $options["class"])), 
				esc_attr(json_encode($pickerOptions)),
				esc_html($options["text"])
			);
	}

	public function languages() {
		return array(
				self::LANG_AF,
				self::LANG_AM,
				self::LANG_AR,
				self::LANG_BG,
				self::LANG_BN,
				self::LANG_CA,
				self::LANG_CS,
				self::LANG_DA,
				self::LANG_DE,
				self::LANG_EL,
				self::LANG_EN,
				self::LANG_EN_GB,
				self::LANG_ES,
				self::LANG_ES_419,
				self::LANG_ET,
				self::LANG_EU,
				self::LANG_FA,
				self::LANG_FI,
				self::LANG_FIL,
				self::LANG_FR,
				self::LANG_FR_CA,
				self::LANG_GL,
				self::LANG_GU,
				self::LANG_HI,
				self::LANG_HR,
				self::LANG_HU,
				self::LANG_ID,
				self::LANG_IS,
				self::LANG_IT,
				self::LANG_IW,
				self::LANG_JA,
				self::LANG_KN,
				self::LANG_KO,
				self::LANG_LT,
				self::LANG_LV,
				self::LANG_ML,
				self::LANG_MR,
				self::LANG_MS,
				self::LANG_NL,
				self::LANG_NO,
				self::LANG_PL,
				self::LANG_PT_BR,
				self::LANG_PT_PT,
				self::LANG_RO,
				self::LANG_RU,
				self::LANG_SK,
				self::LANG_SL,
				self::LANG_SR,
				self::LANG_SV,
				self::LANG_SW,
				self::LANG_TA,
				self::LANG_TE,
				self::LANG_TH,
				self::LANG_TR,
				self::LANG_UK,
				self::LANG_UR,
				self::LANG_VI,
				self::LANG_ZH_CN,
				self::LANG_ZH_HK,
				self::LANG_ZH_TW,
				self::LANG_ZU,
			);
	}

	public function isSupportedLanguage($lang) {
		return in_array($lang, self::languages());
	}

	// Static
	
	public static function __createSchema($defaults = NULL) {
		return parent::__createSchema(array_merge(array(
				self::PROPERTY_VIEWS => new Enum(array(
					Enum::ATTRIBUTE_DEFAULT_VALUE => array(
						self::VIEW_DOCS
					)
				))
			), (array) $defaults));
	}

}