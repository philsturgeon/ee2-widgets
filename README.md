# Widgets

Widgets is a ExpressionEngine 2.1 module that allows even your least experienced client or to manage chunks of intelligent content on there site without needing to learn loads of tags, HTML or call you in to help.

## Installation

Move the "widgets/" folder inside "system/expressionengine/third_party/".

## Concepts

There are 3 types of data involved with the Widgets add-on:

* Widgets: The actual types of widget available, i.e "RSS Feed" or "Google Map"
* Widget Areas: Essentially a group of instances, which go in a certain place like "footer" or "sidebar"
* Widget Instances: A type of widget, with specific data and assigned to an "area"

## Usage

To output a widget area - and therefor all of the instances associated, you can simply use the exp:area tag with the area slug mentioned.

	{exp:widgets:area name="sidebar"}

If you want to customise the wrapping HTML for this widget area you can use double-tag syntax:

	{exp:widgets:area name="sidebar"}
		<div class="widget {slug}">
			<h3>{instance_title}</h3>

			<div class="widget-body">
			{body}
			</div>
		</div>
	{/exp:widgets:area}

That way instances will all be wrapped with different HTML and you could for example remove the instance title from displaying or change class
names.

You can also call up instances on their own:

	{exp:widgets:instance id="5"}

This is less usable and harder to understand when looking at it, but if you want to re-use a widget you can.
