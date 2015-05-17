# Styleguide & Coding standards

Make sure to comment your css declarations like this to have them included in this living styleguide:
<div class="style_markup"><pre class="prettyprint linenums lang-css"><code data-language="css">/\*
Textarea
&nbsp;
It's a textarea.
&nbsp;
Markup:
&lt;textarea&gt;This is content&lt;/textarea&gt;
&nbsp;
Styleguide forms.textarea
\*/
&nbsp;
textarea {
	background: #eee;
}
</code></pre></div>
&nbsp;

The css structure is inspired by SMACSS:
http://smacss.com/book/categorizing

Formatting code is as well inspired by SMACSS:
http://smacss.com/book/formatting

Follow this order to keep the properties clean and easy to use:
* Mixins
* Box
* Border
* Background
* Text
* Other

Example:
<div class="style_markup"><pre class="prettyprint linenums lang-css"><code data-language="css">.component {
	.mixin(); // mixin setting more then one attribute
	&nbsp;
	display: block;
	height: 200px;
	width: 200px;
	float: left;
	position: relative;
	&nbsp;
	border-radius: 10px;
	border: 1px solid #333;
	&nbsp;
	.box-shadow(10px 10px 5px #888);
	background-color: #fff;
	&nbsp;
	font-size: 12px;
	text-transform: uppercase;
}
</code></pre></div>
&nbsp;

For modular css naming conventions please follow:
http://smacss.com/book/type-module

DISCLAMER: However we will use the name "component" instead of "module".

Follow this order to keep the component clean and easy to use:
* Component (For multiple-word class names separate with underscore "_")
  * Component modifiers (Separate modifiers with 2 dashes "--")
  * Media queries
* Sub-Components (Separate modifiers with 1 dash "-")

Example:
<div class="style_markup"><pre class="prettyprint linenums lang-css"><code data-language="css">/\*
My component
&nbsp;
This is my component
&nbsp;
Markup:
&lt;div class="component component--modifier"&gt;
	&lt;h2&gt;Component with modifier&lt;/h2&gt;
	&lt;div class="component-sub_component component-sub_component--modifier"&gt;
		&lt;h3&gt;Sub-Component with modifier&lt;/h3&gt;
	&lt;/div&gt;
&lt;/div&gt;
&nbsp;
Styleguide forms.textarea
\*/
.component {
	// Component properties
	&nbsp;
	@media @mobileOnly {
		// Mobile properties for the component
	}
	&nbsp;
	&.component--modifier {
		// Modifier properties
		&nbsp;
		@media @mobileOnly {
			// Mobile properties for the modifier
		}
	}
}
&nbsp;
.component-sub_component {
	// Sub-Component properties
	&nbsp;
	&.component-sub_component--modifier {
		// Sub-Component modifier properties
	}
}
</code></pre></div>
&nbsp;
