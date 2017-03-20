# Bolt :zap: [![Build Status](https://travis-ci.org/kopepasah/bolt.svg?branch=master)](https://travis-ci.org/kopepasah/bolt)

This is a WordPress scaffolding repo configured to setup sites to develop locally and deploy those changes to your site hosted on the [Pantheon platform][3] using [Travis CI][8].

__Why use this repo in lieu of the Pantheon repo?__
* Currently [Pantheon][3] does not support [Git Submodules][4] for plugins or themes.
* The flow for pushing changes to `dev`/`test`/`live` environments do not follow a sustainable model for code, due to all three sharing the `master` branch.

## Workflow

Workflow for development follows the [Github Flow][5], with any new features branching off of `master`.

Workflow for content (database) and deploys (code) follow the [Pantheon Flow][6].

[3]: https://www.getpantheon.com
[4]: https://git-scm.com/book/en/v2/Git-Tools-Submodules
[5]: https://guides.github.com/introduction/flow/
[6]: https://pantheon.io/docs/pantheon-workflow/
[8]: http://travis-ci.org
