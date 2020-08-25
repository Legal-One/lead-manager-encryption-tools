# Lead Manager - Encryption Key Generator

This CLI tool sole purpose is to create public/private key pairs to be sent
to Legal One Lead Manager.
The public key will be used to encrypt the client data on Lead Manager for
GDPR law compliance.
When needed the client (you) can ask for the data again and decrypt it yourself
by using your private key.


## Usage

In order to use the tool one will need
[**Docker**](https://www.docker.com/get-started) installed and configured on
your computer and also access to the command `make` (not required, but highly
recommended).

Once you have the pre-requirements, you can build the docker image with:
```bash
make build
```

Then, to generate the key pair just execute the following command on terminal: 
```
make keygen
```
Your private/public key will be prompted on your screen.

If you desire to have the public/private keys **as files**, you can run:
```
make keygen-write
```
This will generate public/private keys and write them to files.
