#!/bin/bash
rsync -rvzP ./client/dist/* lukas@lw1.at:/var/www/devicedetector/public/ --exclude="*.php" --exclude="icons" --fuzzy --exclude --delete-after -v
