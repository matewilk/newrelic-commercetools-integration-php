FROM alpine:latest

RUN apk add --no-cache bash curl
WORKDIR /app

COPY docker/test/test_script.sh test_script.sh

CMD ["./test_script.sh"]
