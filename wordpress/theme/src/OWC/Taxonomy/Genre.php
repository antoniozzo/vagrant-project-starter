<?php
namespace OWC\Taxonomy;

use Oakwood\AbstractTaxonomy;

class Genre extends AbstractTaxonomy {

	protected $type = 'genre';

	protected $post_types = array( 'book' );

	public $label = 'Genre';

}