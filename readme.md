# Temperature Data Table

This PHP script reads temperature data from a JSON file (`temps.json`) and displays it in a dynamic HTML table. Temperatures are highlighted based on their values:

- **Bright Red**: Maximum temperature.
- **Light Blue**: Minimum temperature.
- **Yellow**: Temperatures above 18°.

## Usage

1. Save the JSON data to a file named `temps.json`.
2. Place the script in the same directory as the JSON file.
3. Run the script on a PHP-enabled server.
4. Open the script in a browser to view the table.

## Requirements

- PHP 8.0 or higher (at least that's what I tested)
- A web server with PHP support
