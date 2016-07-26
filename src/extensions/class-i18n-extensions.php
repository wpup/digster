<?php

namespace Frozzare\Digster\Extensions;

use Frozzare\Digster\Token_Parsers\Trans;

class I18n_Extensions extends \Twig_Extension {

	/**
	 * Returns the token parser instances to add to the existing list.
	 *
	 * @return array
	 */
	public function getTokenParsers() {
		return [
			new Trans()
		];
	}
	/**
	 * Returns a list of filters to add to the existing list.
	 *
	 * @return array
	 */
	public function getFilters() {
		return [
			new \Twig_SimpleFilter( 'trans', [$this, 'trans'] )
		];
	}

	/**
	 * Returns the name of the extension.
	 *
	 * @return string
	 */
	public function getName() {
		return 'digster-i18n';
	}

	/**
	 * Translate message.
	 *
	 * @param  string $message
	 *
	 * @return string
	 */
	public function trans( $message ) {
		$theme  = wp_get_theme();
		$domain = $theme->get('TextDomain');
		return __( $message, $domain );
	}
}
