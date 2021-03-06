<?php

class Crumb {
	private $h5ai, $parts;

	public function __construct( $h5ai ) {

		$this->h5ai = $h5ai;
		$this->parts = array();

		$href = $h5ai->getAbsHref();
		while ( $href !== "/" && $href !== "//" ) {
			$this->parts[] = $href;
			$href = dirname( $href ) . "/";
		}
		$this->parts[] = "/";

		$this->parts = array_reverse( $this->parts );
	}

	public function toHtml() {

		$html = "";
		$idx = 0;
		foreach( $this->parts as $href ) {
			$idx++;
			$classes = "crumb folder" . ( $idx === 1 ? " domain" : "" ) . ( $idx === count( $this->parts ) ? " current" : "" );
			$image = "/h5ai/images/" . ( $idx === 1 ? "home.png" : "crumb.png" );
			$label = $this->h5ai->getLabel( $href );
			$hint = "";

			$code = $this->h5ai->getHttpCode( $href );
			$classes .= " checkedHttpCode";
			if ( $code !== "h5ai" ) {
				if ( $code === 200 ) {
					$hint = "<img class='hint' src='/h5ai/images/page.png' alt='page' />";
				} else {
					$hint = "<span class='hint'>(" . $code . ")</span>";
				}
			}
			
			$html .= "<li class='$classes'>\n";
			$html .= "\t<a href='$href'>\n";
			$html .= "\t\t<img src='$image' alt='>' />" . $label . $hint . "\n";
			$html .= "\t</a>\n";
			$html .= "</li>\n";
		}
		return $html;
	}
}

?>