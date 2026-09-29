# classifieds
Geeklog classifieds plugin (classifieds). Classifieds plugin allows your site members to publish ads on your site.
##Docs
http://geeklog.fr/downloads/index.php/classifieds
##Bugs & feature requests
https://github.com/Geeklog-Plugins/classifieds/issues
##Contributing
1. Fork it
2. Create your feature branch (git checkout -b my-new-feature)
3. Commit your changes (git commit -am 'Add some feature')
4. Push to the branch (git push origin my-new-feature)
5. Create new pull request


## 1.4.0 development

The `classifieds_1.4.0` branch is the modernization branch.

Current development changes include:

- removal of installation and upgrade telemetry;
- integration of the historical Pro lifecycle email notifications;
- integration of scheduled expiration notifications;
- integration of republish/copy functionality and image copying;
- removal of runtime dependency on `classifieds_data/proversion/proversion.php`;
- removal of "limited edition" / "Pro version" branding;
- protection of the normal 1.3.2 -> 1.4.0 upgrade from the legacy public-folder move, which is unsafe for shared-files deployments.

The old Pro file, if still present in a site's private data directory, is ignored by 1.4.0 code and is not deleted automatically.

See `ROADMAP.md` for the remaining modernization work.
