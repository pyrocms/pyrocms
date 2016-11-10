# Latest Posts Widget

### Note:
This is under consideration to be included in the core for after 2.2.1  Documentation may reflect that it is now named 'Latest Posts' or 'Latest Posts Extended'.

### Description
Displays most recent number of posts with partial content.

### License: MIT
Copyright (C) 2013 Michael Webber
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

### PyroCMS Compatibility
2.2.x - Yes - tested on 2.2.1
2.1.x - untested but should work.


### Installation: 
1: Download and rename the package directory to "latest_posts" if needed.
2: upload into /addons/default/widgets/ :OR: /addons/shared_addons/widgets/

### Use:
#### In a page body:
1: Install
2: ACP --> Content --> Widgets
3: Click "Areas" 
4: Create uniquely named new area
5: Click "instances"
6: drag "latest_posts" to your newly created area and configure
7: copy code: {{ widgets:area slug="WHATEVER-YOU-NAMED-IT" }} and place in [new] page
8: Make sure to have some live blog posts or nothing will be shown.

#### In a sidebar:
1: drag "latest_posts" to your sidebar widget and configure

#### Character Limiting
1: Character limiting is available for each instance of the widget as you insert it into an area. Must be an integer.


### Issues or Bugs:
https://github.com/wbc-mike/latest_posts_extended/issues

### To Do
1: Allow User to choose intro or content

### Thanks:
Erik Berman - PyroCMS Dev Team - Author of Latest Posts which this widget is built upon.

Changelog
1.1.1 - Name change to core widget name
1.1.0 - Added Character limiting, bug fix (no results error on display page) on 1.0.0, moved from displaying intro to content
1.0.0 - initial release
