<div style="text-align: right; color: #718096; font-family: sans-serif; font-size: 0.85em; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px; margin-bottom: 30px;">
    <span>CSE327 Project Documentation</span> &bull; <span>Group 6 Refactor</span>
</div>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap');

body {
    font-family: 'Inter', sans-serif;
    line-height: 1.6;
    color: #2d3748;
    max-width: 850px;
    margin: 0 auto;
    padding: 40px;
    background-color: white;
}

/* Headings */
h1 { font-size: 2.5em; color: #1a202c; border-bottom: 3px solid #3182ce; padding-bottom: 0.3em; margin-top: 1em; }
h2 { font-size: 1.75em; color: #2c5282; margin-top: 2em; border-bottom: 1px solid #e2e8f0; }
h3 { color: #2b6cb0; margin-top: 1.5em; }

/* Code Blocks */
pre {
    background-color: #f7fafc;
    border: 1px solid #cbd5e0;
    border-radius: 8px;
    padding: 1.5em;
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.9em;
    overflow-x: auto;
    page-break-inside: avoid;
}
code {
    font-family: 'JetBrains Mono', monospace;
    background-color: #edf2f7;
    padding: 0.2em 0.4em;
    border-radius: 4px;
    font-size: 0.9em;
    color: #c53030;
}

/* Tables and Blockquotes */
table { border-collapse: collapse; width: 100%; margin: 2em 0; font-size: 0.9em; page-break-inside: avoid; }
th { background-color: #2d3748; color: white; padding: 12px; text-align: left; }
td { border-bottom: 1px solid #e2e8f0; padding: 12px; }
tr:nth-child(even) { background-color: #f7fafc; }

blockquote {
    border-left: 4px solid #3182ce;
    background-color: #ebf8ff;
    margin: 1.5em 0;
    padding: 1em;
    color: #2c5282;
    page-break-inside: avoid;
}

/* Print Tweaks */
@media print {
    body { padding: 0; max-width: 100%; }
    h1 { page-break-before: always; }
    h1:first-of-type { page-break-before: auto; }
}
</style>

# PHPDoc Guide

## What is PHPDoc?

PHPDoc is a documentation standard for PHP code. It allows you to write special comments that can be automatically converted into professional documentation websites.

## How PHPDoc Works

PHPDoc comments start with `/**` and end with `*/`. Inside, you use special tags that start with `@`:

```php
/**
 * Calculate the total price including tax
 * 
 * @param float $price The base price
 * @param float $taxRate The tax rate as a decimal (e.g., 0.15 for 15%)
 * @return float The total price with tax included
 */
function calculateTotal($price, $taxRate) {
    return $price * (1 + $taxRate);
}
```

## Common PHPDoc Tags

| Tag | Purpose | Example |
|-----|---------|---------|
| `@param` | Describes a function parameter | `@param string $name User's name` |
| `@return` | Describes what the function returns | `@return bool True if successful` |
| `@throws` | Describes exceptions the function might throw | `@throws Exception When email is invalid` |
| `@var` | Describes a variable's type | `@var array $users List of all users` |
| `@property` | Documents a class property | `@property string $email User's email address` |

## Generating Documentation

### Step 1: Install PHPDocumentor

```bash
composer require --dev phpdocumentor/phpdocumentor
```

### Step 2: Generate Documentation

```bash
vendor/bin/phpdoc -d app -t docs/api
```

### Step 3: View Documentation

Open `docs/api/index.html` in your browser.

## Benefits of PHPDoc

- Auto-generates beautiful documentation websites
- IDEs use it for autocomplete suggestions
- Makes code easier for other developers to understand
- Industry standard (used by Laravel, Symfony, etc.)