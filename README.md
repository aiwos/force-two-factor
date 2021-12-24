# force-two-factor
Redirects any user which hasn't setup two factor authentication yet to /2fa/. Use together with the forked two-factor plugin at https://github.com/aiwos/two-factor featuring the frontend totp activation shortcode.

Instructions:
- Download, install and activate the customized 'Two Factor' plugin: https://github.com/aiwos/two-factor/releases.
- Make sure there is a page with '2fa' as slug and with the [two-factor-set-totp] shortcode as content.
- Download, install and activate the 'Force Two Factor' plugin.
- Now every user which hasn't set up a two factor authentication is automatically redirected to 'siteurl/2fa/'.
- use 'aiwos/force-two-factor/force-2fa-condition' filter to add additional redirect conditions (don't redirect if false).

