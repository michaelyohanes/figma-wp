# Figma Real Estate Template to WordPress

## Status
**Unfinished**, due to the problems mentioned below.


## Planned Steps

1. [x] Prepare the `docker-compose.yml` file.  
   Versions used:
   - **WordPress**: 7.0 (to ensure plugin compatibility)
   - **PHP**: 8.3 (for broader compatibility)
   - **MariaDB**: 10.6 (used because MySQL 8.0 initialization took over 5 minutes on my HDD)
2. [x] Identify Figma templates, assets, and typography:
   - [x] Fonts (Urbanist from Google Fonts)
   - [x] Typography (text styling, H1, H2, etc.)
   - [x] Assets (downloaded all images used within the template)
3. [ ] Identify plugins closest to the template design (if none are found, use Kadence Blocks):
   - [x] Found a close match: [WP Directory Kit](https://wpdirectorykit.com/themes/moison/)
   - [ ] Install the plugin and customize it accordingly
   - [ ] Revert to Kadence Blocks if customizing the WP Directory Kit template takes too much time
4. [ ] Insert a few listings as initial product data:
   - [x] Add custom fields for the products
   - [x] Insert the product data
5. [ ] Apply Figma styling to the WordPress template:
   - [ ] Extract CSS styles for typography, elements, etc.
   - [ ] Adjust the layout accordingly
   - [ ] Apply styles to the WordPress theme
6. [ ] Check layout and appearance in responsive mode.
7. [x] Dump the MariaDB database into an SQL file for Docker initialization.
8. [x] Commit changes to the repository.


## Problems
The primary issues stem from not having active subscriptions for the WP plugins and Figma:
- Although the [WP Directory Kit](https://wpdirectorykit.com/themes/moison/) template is free, its supporting plugins (such as Elementor) require a Pro subscription to be fully useful.
- The Figma template contains many elements, and without access to "Dev Mode" on the free tier, exporting the code as CSS is highly time-consuming.


## How to Run
1. Rename `.env.example` to `.env` and adjust the variables if required.
2. Run `docker-compose up -d`.
3. Wait for Docker to spin up the services.
4. Access the site at [http://localhost:8000](http://localhost:8000).

*Note: This is for private use only*