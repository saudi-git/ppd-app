PPD-PIMS Session Security Update
================================

This package adds centralized session security without changing the existing UI/database structure.

Changes:
- Added session.php with:
  - HttpOnly session cookie
  - SameSite=Lax
  - Secure cookie automatically enabled under HTTPS
  - PHP strict session mode
  - Cookie-only sessions
  - 30-minute inactivity timeout
  - Session cleanup after timeout
- Updated pages that used session_start() to load session.php.
- Updated index.php to regenerate the session ID after successful login.
- Updated logout.php to clear the session, remove the cookie, and destroy the session.

Important:
- Test this first on localhost/XAMPP.
- The 30-minute timeout is inactivity-based.
- This update does NOT yet add role/permission enforcement, CSRF protection, upload hardening, or SQL refactoring.
- Make a backup of your current working system before replacing files.
