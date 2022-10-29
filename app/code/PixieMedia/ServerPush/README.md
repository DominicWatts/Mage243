# Pixie Media ServerPush

## nginx conf

Syntax example

```
[...]

server {
    listen 80;
    listen 443 ssl http2; # http2 flag required
    listen [::]:443 ssl http2; # http2 flag required
    
    http2_push_preload on; # enable preload
    http2_max_concurrent_pushes 25; # max pushes per request
    
    fastcgi_buffers 32 32k;
    fastcgi_buffer_size 64k;
    
    [...]
    
```
