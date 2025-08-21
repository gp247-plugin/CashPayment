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


