# Livingstreets.com Custom WordPress Theme README

This repo gets pushed to: https://github.com/sgwdc/livingstreets

Live server: http://livingstreets.com/

Back-end administration: http://livingstreets.com/wp-admin/

All individual projects are "Pages" which must be under the parent page "Z-Projects Parent":
* Pages: http://livingstreets.com/wp-admin/edit.php?post_type=page

To actually appear on the website, an individual project must be added to at least one page category:
* Page categories: http://livingstreets.com/wp-admin/edit-tags.php?taxonomy=category&post_type=page

## Important: Each of the page categories must correlate with a page by the same name (*or is it the same slug?*)  For example:
* Interactive Mapping page: http://livingstreets.com/wp-admin/post.php?post=187&action=edit
* Interactive Mapping category: http://livingstreets.com/wp-admin/term.php?taxonomy=category&tag_ID=17

The end user interface is driven by the "Essential Grid" plugin by ThemePunch:
* Documentation: https://www.themepunch.com/essgrid-doc/essential-grid-documentation/
* Settings: http://livingstreets.com/wp-admin/admin.php?page=essential-grid

    | Alias/slug | Displays | Implemented on |
    | - | - | - |
    | portfolio_home *(rename to portfolio_categories)* | Large Categories | Home page, and Project pages |
    | portfolio_category *(rename to portfolio_projects)* | Large Projects | Category Pages |
    | portfolio_small | Small Categories & Projects | Home Page (all projects)<br>Category Pages (other categories)<br>Project Pages (other projects) |
