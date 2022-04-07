# Release notes for Blog plugin

## v.2.0.1 (2022-04-07)

### Behoben

- The blog plugin is now compatible with cache blocks.
- A error due the loading process of the category tree got fixed.

## v.2.0.0 (2021-05-14)

### Feature 

- The blog plugin is now compatible with Vue Server-Side Rendering (SSR).

## v1.1.9 (2020-02-27)

- Extend debug assistant's functionality

## v1.1.8 (2020-02-27)

- Extend debug assistant's functionality

## v1.1.7 (2020-01-15)

- Extend debug assistant's functionality

## v1.1.6 (2020-01-10)

- Extend debug assistant's functionality

## v1.1.5 (2019-11-1)

- Extend debug assistant's functionality

## v1.1.4 (2019-10-31)

- NEW - Debug assistants to fix common issues in your blog posts. These assistants can be enabled in Blog plugin settings.
- FIX - Search page layout

## v1.1.3 (2019-08-20)

- FIX - Added load more button on the default view in the category list

## v1.1.2 (2019-07-30)

### Feature
- You can now select which category type should be displayed in the blog header navigation 
    + Only categories of type blog (default)
    + Same categories as in the rest of the shop

### FIX
- Categories title in sidebar is now translated
- Categories in sidebar will now use the correct language prefix in their urls
- Using search on a different language than the shop default will no longer reset the language


## v1.1.1 (2019-07-25)

### Assistant
- Landing page assistant multilingualism texts are no longer editable in the multilingualism menu

### FIX: Layout
- Single post page: article body will now clear floats

### CHANGE: Layout
- Single post page: title image is no longer limited to 300px height - Warning: Since we're no longer limiting the height, tall images will fill a lot more area. Make sure you use wide images instead.

## v1.1.0 (2019-07-17)

### NEW: Layouts
We added several layout options for articles, category pages and the landingpage. Please refer to the plugin guide for details.

### NEW in frontend UI
- Added related posts at the bottom of the article in single article page that show posts from the same category as the opened article
- Added categories menu in sidebar

### NEW in backend UI
- New editor was added.

### CHANGES in UI
- Sidebar is narrower, main page content is wider to focus on the main content more than on the sidebar
- Sidebar latest posts title is no longer truncated and limited to 2 lines, it shows full title now

### CHANGE/FIX Open Graph meta are now properties

## v1.0.2 (2019-06-27)

### NEW: OG Tags added
- title = meta title
- description = meta description
- url = relative url to the article
- image = title image if it's available, otherwise the preview image, if neither is available no og:image tag is set

### NEW: Custom fonts are now supported in the blog

### NEW: Landing page assistant is now available under System >> Assistants >> Omni Channel >> Blog

## v1.0.0 (2019-06-19)

### NEW: Landing page
An assistant was created to set up the blog landing page. 
Separate assistant options for each plugin set and language combination are available.
Settings in the assistant under **System >> Assistants**:
- custom url
- entrypoint message
- back to store message
- landing page title
- landing page meta title
- landing page meta description
- landing page meta keywords
- landing page robots

Landing page acts like a category. Looks like a category of type blog.
- adjust route for categories to contain custom url
- adjust route for posts to contain custom url
- adjust route for search and search by tag to contain custom url
**REQUIRES** plugin build to see changes in UI

### Special cases and standards
URLs will work as below:
**Standard**
- /custom - Landing page mentioned above
- /custom/category1 - category of type blog
- /custom/category1/category2 - category of type blog
- /custom/category1/category2/postUrlName - post

**Special**
- /category1 - category of type blog works just as before
- /category1/category2 - category of type blog works just as before
- /custom/category1/category2/b-15 - old post, redirects to new migrated url
    
**Default**
- /custom/ defaults to /blog/ if no custom is given. /blog/ works even if custom is set


### CHANGES: UI
- Hide shopbuilder breadcrumbs on blog pages
- Post short description is no longer displayed on single post page
- Optional ( in plugin config ) setting to automatically link the entrypoint container
- change links in the UI to contain custom url ( categories, posts and search )
- change links in the breadcrumb to contain custom url

Category pages:
- category name in the header is h1
- category name in a post is now a span, was h5
- post title in a post is now a h2, was a simple anchor
Single post page:
- category name in the header is h2
- post title is h1

Blue color is no longer enforced, blog uses Ceres primary color ( if Ceres uses green => Blog will be green as well )
Adjusted left and right paddings on wrapper, desktop screen size, to align the edges better
CSS for blog is now only loaded on blog pages
JS for blog is now only loaded on blog pages
Entrypoint CSS is still loaded on all shop pages
Search inputs are now of type "search", they were of type "text"

### REMOVED
Blog entrypoint category picker from plugin config setting - it's now configurable in the assistant, not a category


## v0.9.3 (2019-03-06)

- FIX - Fix meta tags


## v0.9.2 (2019-02-22)

- FIX - Better image layouts
- FIX -Images in posts are limited to full width
- FIX -Better vertical spacing when images are missing
- NEW -Add default image to latest posts if the latest post does not have an image
- NEW -Add functionality to hide or display the latest posts
- NEw -Add functionality to show how many blog posts you want in the latest posts

## v0.9.1 (2019-01-23)

- NEW - Compatibility with Ceres 3
- NEW - Plugin source code is now public
- FIX - The blog entry point in the online store is no longer visible when no category was selected in the plugin.

## v0.9.0 (2019-01-08)

### Features

- Blog functionality for Ceres online stores
