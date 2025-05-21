# ISO 27001 Security Assessment Platform

## Installation Instructions

### Prerequisites
- PHP 8.1 or higher
- Composer
- MySQL or PostgreSQL database
- Node.js and npm (for frontend assets)

### Setup Steps

1. **Clone or create a new Laravel project:**
```bash
composer create-project laravel/laravel iso27001-assessment
cd iso27001-assessment
```

2. **Configure environment:**
```bash
cp .env.example .env
php artisan key:generate
```

3. **Update your `.env` file with database credentials:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=iso27001_assessment
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

4. **Create the database tables:**
```bash
# Create migration files
php artisan make:migration create_companies_table
php artisan make:migration create_assessments_table

# Run migrations
php artisan migrate
```

5. **Create the models:**
```bash
php artisan make:model Company
php artisan make:model Assessment
```

6. **Create the controller:**
```bash
php artisan make:controller SecurityAssessmentController
```

7. **Install Tailwind CSS (optional, for better styling):**
```bash
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p
```

8. **Start the development server:**
```bash
php artisan serve
```

## File Structure

```
app/
├── Http/Controllers/
│   └── SecurityAssessmentController.php
├── Models/
│   ├── Company.php
│   └── Assessment.php
├── database/migrations/
│   ├── create_companies_table.php
│   └── create_assessments_table.php
└── resources/views/
    ├── app.blade.php
    └── security/
        ├── index.blade.php
        ├── assessment.blade.php
        ├── results.blade.php
        ├── saved-companies.blade.php
        └── edit-assessment.blade.php
```

## Features

### Core Functionality
- **Company Management**: Create and manage company profiles
- **ISO 27001 Assessment**: 20 comprehensive security questions based on ISO 27001 standards
- **Real-time Results**: Instant calculation of compliance scores
- **Pass/Fail Determination**: 70% threshold for ISO 27001 compliance
- **Assessment History**: Track and modify previous assessments
- **Progress Visualization**: Green/red progress bars and detailed breakdowns

### Security Questions Categories
1. Information Security Management System (ISMS)
2. Risk Assessment and Treatment
3. Incident Response
4. Employee Training and Awareness
5. Access Control
6. Supplier Relationships
7. Business Continuity
8. Physical Security
9. Cryptography
10. Monitoring and Auditing

### User Interface Features
- **Responsive Design**: Works on desktop, tablet, and mobile
- **Intuitive Navigation**: Clean, modern interface using Tailwind CSS
- **Visual Feedback**: Progress bars, status indicators, and color-coded results
- **Bulk Operations**: View all assessments in a comprehensive table

## Customization Options

### Adding More Questions
Edit the `$securityQuestions` array in `SecurityAssessmentController.php`:

```php
private $securityQuestions = [
    "Your custom question here?",
    // Add more questions...
];
```

### Changing Pass/Fail Threshold
Modify the passing threshold in the controller:

```php
$passed = $percentage >= 80; // Change to 80% threshold
```

### Custom Styling
- Edit the Blade templates to modify the appearance
- Update Tailwind classes or add custom CSS
- Modify the progress bar styles and colors

## Security Considerations

1. **Input Validation**: All user inputs are validated using Laravel's validation system
2. **CSRF Protection**: All forms include CSRF tokens
3. **Database Security**: Using Eloquent ORM prevents SQL injection
4. **Access Control**: Consider adding authentication for production use

## Deployment

### Production Deployment
1. Set `APP_ENV=production` in `.env`
2. Run `php artisan config:cache`
3. Run `php artisan route:cache`
4. Set up proper web server configuration (Apache/Nginx)
5. Configure SSL certificates
6. Set up regular database backups

### Optional Enhancements
- Add user authentication with Laravel Breeze/Jetstream
- Implement role-based access control
- Add PDF report generation
- Include email notifications for completed assessments
- Add audit trails for assessment changes
- Implement API endpoints for integration with other systems

## License

No.

## Model website:
[https://iso-security.vercel.app](https://iso-security.vercel.app)