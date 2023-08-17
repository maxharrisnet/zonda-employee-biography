# Zonda Technical Challenge - by Max Harris

This plugin is written by Max Harris for a coding assessment for the Senior Web Developer (WordPress CMS) role at Zonda. The function of the plugin is to create a shortcode that displays biographical information of employees.

## Prompt

```
This shortcode is part of a plugin and has its own stylesheet if the shortcode is used on a page.

For the admin side of things, you can use Advance Custom Fields for the specific fields.

The requirements are to have these fields for bio template

1. Person Name
2. Person Image
3. Position Title
4. Division Title
5. Optional Division Logo
6. How long with the company
7. Bios text

For the output of the shortcode, make sure it is used to display this information in a ADA compliant matter on a theme of your choice.
```

## Functionality

The plugin registers a custom post type: `zonda_employee` and a custom taxonomy: `zonda_division`. This taxonomy can be used to group employees by division. There are also custom columns in WordPress admin to reflect the custom meta fields.

The plugin also registers a shortcode: `[zonda_employee]`. The output of the shortcode is a list of employees, or a single employee. The list of employees is displayed in a grid, with each employee being a card. The single employee is displayed in a card. The card displays the employee's name, position, division, and bio. The card also displays the employee's image, and the division's logo if it exists.

Custom meta fields are adding using Advanced Custom Fields. This includes sanitization on the fields to ensure that the data is safe to save. Output is localized and escaped according to the expected data and context in which it is displayed.

## Testing

## Extensibility

To take this plugin further, I would add the following features:

- Have shortcode accept the slug of the division to display
- Create archive and single templates for the custom post type and taxonomy
- Save the Employee first and last name as the title and slug
- More robust sanitization of the custom meta fields
- Real localization
- Use a CSS preprocessor to write Sass
- Allow WEBP and SVG images
- Better image output/sizing
- Limit date ranges for the start_date field
- Limit permissions for adding divisions
- Consistency between array and object notation
- Probably more function checks
- Include ACF locally https://www.advancedcustomfields.com/resources/including-acf-within-a-plugin-or-theme/
- Enqueue conditionally according to shortcode presence in content
- Create a custom block for the Gutenberg editor
- Use OOP rather than functional programming/namespacing
- Get me hired at Zonda so that I can buy a house

---

Thank you for your consideration!
