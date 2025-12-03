# Contributing to CSE327 Group 6 Project

Welcome to the CSE327 Group 6 project! We appreciate your interest in contributing. This document provides guidelines for working on the project, submitting changes, and maintaining code quality.

## Getting Started

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/Nasim227/CSE327_Group-6.git
    cd CSE327_Group-6
    ```

2.  **Install dependencies:**
    ```bash
    composer install
    npm install
    ```

3.  **Set up environment:**
    - Copy `.env.example` to `.env`
    - Configure your database settings in `.env`
    - Run migrations: `php artisan migrate`
    - Generate key: `php artisan key:generate`

4.  **Run the application:**
    ```bash
    php artisan serve
    npm run dev
    ```

## Branching Strategy

We use a feature-branch workflow.

-   **`Sadman`**: The main development branch (currently).
-   **Feature Branches**: Create a new branch for each feature or fix.
    -   Format: `feature/your-feature-name` or `fix/bug-description`
    -   Example: `feature/user-authentication`, `fix/login-error`

**Never push directly to the main branch.** Always use a Pull Request.

## Development Workflow

1.  **Create a branch:**
    ```bash
    git checkout -b feature/my-new-feature
    ```

2.  **Make changes:**
    -   Write clean, readable code.
    -   Add comments for complex logic (Teaching comments are encouraged!).
    -   Follow Laravel naming conventions.

3.  **Test your changes:**
    -   Run the test suite: `php artisan test`
    -   Ensure all tests pass before committing.

4.  **Commit changes:**
    -   Write clear, descriptive commit messages.
    -   Example: `feat: add user profile page` or `fix: resolve database connection issue`

5.  **Push and Pull Request:**
    ```bash
    git push origin feature/my-new-feature
    ```
    -   Open a Pull Request (PR) on GitHub.
    -   Request a review from a team member.

## Testing

We use PHPUnit for testing.

-   **Run all tests:** `php artisan test`
-   **Run specific test:** `php artisan test --filter TestName`

Please ensure your code is covered by tests where possible.

## Code Style

-   Follow PSR-12 coding standards.
-   Use meaningful variable and function names.
-   Keep controllers skinny and models fat (business logic in models or services).

## Code of Conduct

-   Be respectful and collaborative.
-   Constructive criticism is welcome in code reviews.
-   Help each other learn and grow.

Happy Coding!
