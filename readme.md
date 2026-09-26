### 1. Overview
Cash payment plugin for GP247/Shop. Suitable for offline cash collection (e.g., cash on delivery). Orders are created successfully and payment is collected outside the system between buyer and seller.

### 2. Features
- Adds a "Cash on delivery" payment method to checkout
- No online transaction handling; orders remain pending until cash is collected
- Can be enabled/disabled from the admin panel
- Compatible with core 1.1+; uses the `gp247/shop` package

### 3. Installation
You can install the plugin in one of the following ways:

1) Online installation: open the Plugin library in Admin and search for "Cash payment" to install.
2) Upload ZIP: upload the plugin ZIP package from the Admin panel.
3) Manual installation: extract and copy to `app/GP247/Plugins/CashPayment`, then open Admin and save local configuration.

Reference (Vietnamese) installation guide: `https://gp247.net/vi/docs/user-guide-extension/guide-to-installing-the-extension.html`

#### Install from the command line (CLI, gp247 3.x)

Since gp247 3.x you can download **CashPayment** from the GP247 library and install it straight from the command line, without opening the admin. The plugin requires the `gp247/shop` package on the website. Open a terminal in the website's root folder and run:

```bash
# 1) Once per website: register the (free) API License that connects the site to the GP247 library
php artisan gp247:ext-register-license

# 2) Download the plugin from the library and install it
php artisan gp247:ext-install --type=plugin --key=CashPayment
```

- Before step 1, make sure `APP_URL` in `.env` is the website's **real domain** (not `http://localhost`) — the license is bound to that domain.
- Once installed, the plugin is **enabled** and caches are refreshed automatically; nothing else is needed in the admin.
- The command checks the requirements declared in `gp247.json` (core version, composer packages, required plugins) and stops with a clear message if something is missing (e.g. `gp247/shop` is not installed).
- If the folder `app/GP247/Plugins/CashPayment` is already on the server (copied manually or shipped with the installer), the command **installs it in place** instead of downloading it again.
- The command refuses a plugin that is already installed. To move to a newer version, run `php artisan gp247:ext-update --type=plugin --key=CashPayment`.
- Append `--json` to get machine-readable output (for scripts/CI).
- More: [Installing Plugins & Templates](https://github.com/gp247net/gp247-docs/blob/main/extension/install-extension.md) · [Command reference](https://github.com/gp247net/gp247-docs/blob/main/system/command-line-reference.md).

### 4. Usage
- In Admin: Plugins → Payment → enable "Cash payment".
- No additional configuration is required for this method.
- On the storefront checkout page, buyers select "Cash on delivery".
- The order will remain pending payment until it is confirmed as paid.

### 4. Documentation
- GitHub: `https://github.com/gp247net/CashPayment`
- Guide (Vietnamese): `https://gp247.net/vi/docs/user-guide-extension/guide-to-installing-the-extension.html`

### 5. License
Developed by GP247


