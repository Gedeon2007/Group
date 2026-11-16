FROM php:8.3-cli-alpine
WORKDIR /var/www/html
COPY . /var/www/html
RUN addgroup -S app && adduser -S app -G app \
    && chown -R app:app /var/www/html
USER app
ENV PORT=10000
EXPOSE 10000
CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-10000} -t /var/www/html /var/www/html/router.php"]
