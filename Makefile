
build:
	@echo "Building the docker image..."
	@docker build . -t legalone/lead-manager-keygen:latest

keygen:
	@echo ""
	@echo ""
	@docker run legalone/lead-manager-keygen:latest php /app/keygen.php --no-write
