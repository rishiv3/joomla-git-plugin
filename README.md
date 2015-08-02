# Joomla Git Plugin

This is a work in progress, but if you are tracking your Joomla site in git, this plugin will automatically check for altered files and commit them onAfterRender. This is a rough draft, alpha release, so please treat it as such. It is not yet error tolerant and could use some love.

### Setup

**_NOTE: This plugin can NOT set up git on your server, create a git repository, or set up a remote git repository. If you don't know how to set up git on your server, don't use this plugin. at all. Even if you do, check the wiki on this repo for some issues you might run into and how to resolve them._**

Install as a normal Joomla plugin.

Enable it in the Plugin Manager.

You may need to update the git path if git is not available in the system path.

Update the branch you wish to commit to, make sure the branch is already created! The plugin does not try to branch for you.

Update the default commit message. "[date]" will be replaced with the current server date and time.

Set the Commit Frequency - how often you'd like the plugin to commit changes.

If you want to push changes to a remote repository, enabled that.

Set the remote (either the ssh remote url, or an alias that you've set up), and the remote branch to commit to.

Set the Push Freqency - how often you'd like the plugin to push changes. (recommended to be equal to or greated tham the commit frequency)

### Why?

Sometimes you just need to track the entire Joomla install with git, but once the site goes live the files can be easily modified and out of sync with the main repository. This allows you to auto-commit the changes into a separate branch, which you can then later merge.

Sometimes you also are only tracking some specific directories and this can also keep the changes in sync if they are changing on the site.

### Stuff In The Works

Trigger from URL - allow you to trigger the plugin from a url, including which actions you want to do (commit and/or push), as well as setting a custom commit message.

### License

GNU General Public License version 3 or later.

***

[idk, tweet me @219jondn or something](http://twitter.com/219jondn "Tweet at @219jondn")