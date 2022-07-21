FROM nginx:mainline-alpine

EXPOSE 80

# RUN rm /etc/nginx/sites-enabled/default
RUN rm /etc/nginx/conf.d/*
COPY ./nginx.conf /etc/nginx/conf.d/
COPY ./app /var/www/app
