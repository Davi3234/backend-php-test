FROM ubuntu:latest
LABEL authors="davif"

ENTRYPOINT ["top", "-b"]