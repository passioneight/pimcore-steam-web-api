# Configuration
The following configuration is available for this bundle:

```yaml
pimcore_steam_web_api:
    key: 'your-key' # string; required
    base_url: 'https://api.steampowered.com'  # string; optional
    
    open_id:
        link_account_redirect: 'app_account_profile' # string; required
        unlink_account_redirect: 'app_account_profile' # string; required

    parent_folder:
        profiles: '/Steam/Profiles' # string; optional
        games: '/Steam/Games' # string; optional
        achievements: '/Steam/Achievements' # string; optional
        news: '/Steam/News' # string; optional
        badges: '/Steam/Badges' # string; optional
```

### [Next Chapter: Usage](/documentation/20_usage.md)