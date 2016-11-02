#!/usr/bin/env bash

OUT=$(php artisan jwt:generate);
KEY=$(echo $OUT | cut -d "[" -f2 | cut -d "]" -f1);
sed -i '' "s,JWT_SECRET=changeme,JWT_SECRET=$KEY,g" .env
