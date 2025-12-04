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

# Testing Guide - Understanding White Box, Black Box, and Unit Tests

## What is Testing and Why Do We Test?

### The Problem Testing Solves

Testing ensures:
1. **It works correctly** (does what it's supposed to do)
2. **It doesn't break** when you add new features
3. **It's safe** (prevents security issues)
4. **You can prove it works** (for clients, instructors, employers)

### Example

```php
// Without testing:
function divide($a, $b) {
    return $a / $b;
}
// What if $b is 0? App crashes! 💥

// With testing:
function divide($a, $b) {
    if ($b === 0) {
        throw new Exception("Cannot divide by zero");
    }
    return $a / $b;
}
// Test catches this bug before production ✓
```

## Unit Tests Explained

### What is a "Unit"?

A **unit** is the **smallest testable piece** of code:
- A single function
- A single method
- A single class

Think of it like testing individual LEGO bricks before building the castle.

## White Box vs Black Box Testing

### Black Box Testing (External View)

**You DON'T see inside the code. You only see:**
- Input: Bread goes in
- Output: Toast comes out

**Testing approach:**
- Put bread in → Check if toast comes out
- Don't care HOW it toasts
- Only care THAT it toasts

### White Box Testing (Internal View)

**You CAN see inside the code. You test:**
- The heating element gets hot
- The timer counts down correctly
- The spring mechanism pops toast up

**Testing approach:**
- Test each internal component
- Verify internal logic
- Check calculations and algorithms

### Side-by-Side Comparison

| Aspect | Black Box | White Box |
|--------|-----------|-----------|
| **What you test** | Outputs/Results | Internal logic |
| **Knowledge needed** | None (just requirements) | Full code understanding |
| **Example** | "Login works" | "Password hashing works" |
| **File location** | `tests/Feature/` | `tests/Unit/` |
| **Tools** | Browser simulation | Direct class calls |

## Our Project's Tests

### White Box Tests (Unit Tests)

Located in: `tests/Unit/`

**AdminTest.php** - Tests Admin model's internal properties and methods
**UserTest.php** - Tests User model's custom methods
**AuthManagerTest.php** - Tests authentication service logic

### Black Box Tests (Feature Tests)

Located in: `tests/Feature/`

**LoginTest.php** - Tests login flow as a user experiences it
**SignupTest.php** - Tests registration flow as a user would do it

## Running Tests

```bash
php artisan test
```

**Expected output:** "Tests: 45 passed" ✓

## How to Determine What to Test

### The 3-Question Method

For every piece of code, ask:

1. **What does it DO?** (Functional test)
2. **What could go WRONG?** (Edge case test)
3. **Is it SECURE?** (Security test)