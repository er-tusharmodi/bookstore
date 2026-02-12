# 🎨 Admin Panel - Quick Reference Guide

## 🚀 Quick Start

### Admin Login

**URL**: `http://localhost:8000/admin`

- **Email**: `admin@booknest.test`
- **Password**: `password`

---

## 📑 Available Resources

### 📊 Dashboard

Located at: `/admin`
**Features**:

- 12 Interactive widgets with real-time data
- Sales trends, revenue analytics, customer metrics
- Recent orders, alerts, and activity feeds
- Responsive design that works on all devices

---

## 📦 Core Resources

### 1. **Orders** 📦

**Path**: `/admin/orders`

- Manage all customer orders
- View order details, totals, and status
- Update order status and notes
- Filter by status, date range, customer

**Fields**: Order #, Customer, Store, Total, Status, Date

---

### 2. **Books** 📚

**Path**: `/admin/books`

- Manage book catalog
- Add/edit ISBN, price, description
- Assign authors, genres, formats
- Upload cover images

**Fields**: Title, ISBN, Author, Price, Genre, Status

---

### 3. **Authors** ✍️

**Path**: `/admin/authors`

- Manage author profiles
- Add biographies and images
- Track author statistics

**Fields**: Name, Email, Phone, Biography, Created Date

---

### 4. **Reviews** ⭐

**Path**: `/admin/reviews`

- Monitor customer reviews
- Approve/reject reviews
- View ratings and comments
- Filter by approval status

**Fields**: Book, Reviewer, Rating, Title, Approved Status

---

### 5. **Coupons** 🎟️

**Path**: `/admin/coupons`

- Create and manage discount codes
- Set discount type (percentage or fixed)
- Define usage limits and expiry dates
- Monitor coupon effectiveness

**Fields**: Code, Discount %, Min Purchase, Usage Count, Expiry

---

### 6. **Inventory** 📦

**Path**: `/admin/inventory`

- Track stock levels per store
- Monitor reorder levels
- View pricing and SKU details
- Low stock alerts

**Fields**: Store, Book, SKU, Quantity, Reorder Level, Status

---

### 7. **Customers** 👥

**Path**: `/admin/customers`

- View customer profiles
- Track order history and spending
- Monitor email verification status
- Customer analytics

**Fields**: Name, Email, Orders Count, Total Spent, Member Since

---

### 8. **Genres** 🏷️

**Path**: `/admin/genres`

- Manage book categories
- Add new genres
- Organize book classifications

**Fields**: Name, Description, Icon, Status

---

### 9. **Formats** 📖

**Path**: `/admin/formats`

- Define book formats (Hardcover, Paperback, E-Book, etc.)
- Manage format properties

**Fields**: Name, Description, Pricing Adjustments

---

### 10. **Stores** 🏪

**Path**: `/admin/stores`

- Manage physical or virtual store locations
- Configure store details and inventory

**Fields**: Name, Location, Manager, Phone, Status

---

### 11. **Pages** 📄

**Path**: `/admin/pages`

- Create/manage static pages
- SEO optimization
- Content management

**Fields**: Title, Slug, Content, Published Status

---

### 12. **Site Settings** ⚙️

**Path**: `/admin/site-settings`

- Global website configuration
- Maintenance mode settings
- Analytics setup

**Fields**: Key, Value, Description, Type

---

### 13. **Homepage Settings** 🏠

**Path**: `/admin/homepage-settings`

- Customize homepage appearance
- Featured books, promotions
- Hero section content

**Fields**: Setting Key, Setting Value, Display Order

---

### 14. **Users** 👤

**Path**: `/admin/users`

- Manage system users
- View roles and permissions
- User account settings

**Fields**: Name, Email, Role, Status, Last Login

---

## 🎨 Design Features

### Dark Mode Theme

- **Enabled by default** for comfortable viewing
- Eye-friendly dark backgrounds (#1e293b)
- Light text (#f1f5f9) for excellent contrast

### Color Scheme

| State          | Color             | Appearance             |
| -------------- | ----------------- | ---------------------- |
| Primary Action | Indigo (#4f46e5)  | Buttons, active states |
| Success        | Emerald (#10b981) | Success notifications  |
| Warning        | Amber (#f59e0b)   | Caution alerts         |
| Danger         | Rose (#f43f5e)    | Error/delete actions   |
| Info           | Blue (#0ea5e9)    | Information messages   |

---

## 🎯 Common Tasks

### Create a New Book

1. Go to **Books** resource
2. Click **+ Create Book**
3. Fill in details (Title, ISBN, Price, Description)
4. Select Author and Genre
5. Upload cover image
6. Click **Save**

### Add a New Coupon

1. Navigate to **Coupons**
2. Click **+ Create Coupon**
3. Enter coupon code
4. Choose discount type (% or fixed amount)
5. Set usage limits and expiry date
6. Click **Save**

### Update Inventory

1. Go to **Inventory**
2. Find the book entry
3. Click to edit quantity
4. Update stock and reorder level
5. Save changes

### Approve Customer Reviews

1. Open **Reviews** resource
2. Filter by "Pending Review"
3. Click to view review details
4. Click **Approve** to accept
5. Updates reflect immediately

### Monitor Orders

1. Visit **Orders** dashboard
2. Filter by status (Pending, Processing, Shipped)
3. Click order to view details
4. Update status as it progresses
5. Add notes for customer communication

---

## 🔍 Search & Filter Features

### Quick Search

- Available on all resource tables
- Search by name, title, email, code
- Real-time results as you type

### Advanced Filters

**Example - Orders**:

- Status (Pending, Processing, Shipped, Delivered, Cancelled)
- Date range (This month, Last 30 days, Custom)
- Store/Customer selection

**Example - Inventory**:

- Status (Active, Inactive, Discontinued)
- Low stock items
- By store location

---

## 📊 Dashboard Widgets

### Stats Overview

- **Total Revenue**: Sum of all order totals
- **Total Orders**: Count of all orders
- **Avg Order Value**: Revenue ÷ Orders
- **Total Books**: Count of books in catalog
- **Total Customers**: Count of registered customers
- **Pending Orders**: Count of not-yet-processed orders

### Charts & Analytics

- **Orders Chart**: 12-month trend
- **Revenue Chart**: 12-month financial overview
- **Top Selling Books**: Best performers by units sold
- **Customer Acquisition**: Growth trend over 12 months
- **Genre Distribution**: Book category breakdown
- **Order Status Distribution**: Current order statuses

### Data Tables

- **Recent Orders**: Last 10 orders with customer names
- **Low Stock Alerts**: Inventory below reorder levels
- **Active Coupons**: Currently valid discount codes

---

## ⚡ Keyboard Shortcuts

| Shortcut       | Action                   |
| -------------- | ------------------------ |
| `Ctrl/Cmd + K` | Global search            |
| `Ctrl/Cmd + /` | Toggle sidebar           |
| `Escape`       | Close modal              |
| `Ctrl/Cmd + S` | Submit form              |
| `Ctrl/Cmd + Z` | Undo (browser dependent) |

---

## 🔐 Security Features

### Authentication

- Secure login with email/password
- Session management
- Auto-logout on inactivity

### Authorization

- Role-based access control
- Admin-only resource access
- Audit trail for changes

---

## 🎨 Customization Guide

### Change Primary Color

Edit `app/Providers/Filament/AdminPanelProvider.php`:

```php
->colors([
    'primary' => Color::Indigo,  // Change this
    // other colors...
])
```

### Adjust Sidebar Width

In the same file:

```php
->sidebarWidth('24rem')  // Adjust size (default: 20rem)
```

### Add Custom CSS

Edit `resources/css/admin-theme.css` to modify:

- Colors and backgrounds
- Shadows and borders
- Spacing and padding
- Font sizes and weights

### Enable Light Mode

```php
->darkMode(false)  // Disable dark mode
->defaultThemeMode(ThemeMode::Light)
```

---

## 🐛 Troubleshooting

### Styles Not Updating

1. Clear cache: `php artisan config:clear`
2. Clear views: `php artisan view:clear`
3. Refresh browser (Cmd/Ctrl + Shift + R)

### Sidebar Not Showing

- Check browser zoom level (try 100%)
- Clear browser cache
- Disable browser extensions

### Forms Not Saving

- Check for validation errors (red messages)
- Ensure all required fields are filled
- Verify user has permission to edit

---

## 📱 Mobile Access

The admin panel is fully responsive:

- **Desktop**: Full sidebar + content
- **Tablet**: Collapsible sidebar
- **Mobile**: Touch-optimized forms and tables

---

## 💡 Tips & Tricks

### Fast Navigation

- Use breadcrumbs to jump between sections
- Use search to find resources quickly
- Collapsed navigation groups for cleaner sidebar

### Bulk Actions

- Select multiple rows
- Apply actions to all selections
- Use filters to narrow scope

### Data Export

- Most tables support filtering
- Use browser print function for reports
- Export data via action buttons

---

## 📞 Support Resources

### Server Location

- **Local**: `http://localhost:8000/admin`
- **Running on**: Port 8000 (you can change in artisan serve)

### Logs Location

- **Application Logs**: `storage/logs/laravel.log`
- **Query Logs**: Check database connection settings

### Documentation

- **Laravel**: https://laravel.com/docs
- **Filament**: https://filamentphp.com/docs
- **Tailwind CSS**: https://tailwindcss.com/docs

---

## 🎉 You're Ready!

Your admin panel is fully set up with:

- ✅ Beautiful dark theme
- ✅ 14 powerful resources
- ✅ Real-time analytics dashboard
- ✅ Professional design system
- ✅ Mobile-responsive interface

**Happy administrating!** 🚀
