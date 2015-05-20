<?php
namespace OWC\Taxonomy;

use Oakwood\AbstractTaxonomy;

class Genre extends AbstractTaxonomy {

	public $type = 'genre';

	public $post_types = array( 'book' );

}