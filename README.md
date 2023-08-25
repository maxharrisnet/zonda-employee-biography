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

The plugin also registers a shortcode: `[zonda_employee_biography]`. The output of the shortcode is a list of employees, or a single employee . The list of employees is displayed in a grid, with each employee being a card. The single employee is displayed in a card. The card displays the employee's name, position, division image and title, and a link to the bio.

Custom meta fields are added using Advanced Custom Fields. This includes sanitization on the fields to ensure that the data is safe to save. Output is localized and escaped according to the expected data and context in which it is displayed.

There's a custom simple archive template and url, and the custom post type is setup to save the post name as the employee's name. This allows for a pretty permalink structure.

## Styling

The styling is intentionally minimal, allowing the theme's styles to be applied to the output of the shortcode. Flexbox is used to create a responsive grid of "cards".

## Usage

- Display all employees: `[zonda_employee_biography]`
- Display a single employee: `[zonda_employee_biography ids="1384"]`
- Display multiple employees: `[zonda_employee_biography ids="1385,1386,1365"]`

## Extensibility

To take this plugin further, I would add the following features:

- Have shortcode accept the slug of the division to display
- Real localization
- Use a CSS preprocessor to write Sass
- Allow WEBP and SVG images
- Register and use a custom image size
- Limit date ranges for the start_date field
- Limit permissions for adding divisions
- Add fields to Quick Edit
- Better admin [columns](https://developer.wordpress.org/reference/hooks/manage_post_type_posts_columns/) with sorting
- Better archive page
- Consistency between array and object notation
- More function checks
- [Include ACF locally](https://www.advancedcustomfields.com/resources/including-acf-within-a-plugin-or-theme/)
- Enqueue styles conditionally according to shortcode presence in content
- Use OOP rather than functional programming/namespacing
- Create a custom block for the Gutenberg editor

---

Thank you for your consideration!
