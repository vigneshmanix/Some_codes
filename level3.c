#include <stdlib.h>
#include <unistd.h>
#include <string.h>
#include <sys/types.h>
#include <stdio.h>

int main(int argc, char **argv, char **envp)
{
 char *buffer;

 setuid(1002);
 setuid(1002);

 buffer = NULL;

 asprintf(&buffer, "/bin/echo %s is cool", getenv("USER"));
 printf("about to call system(\"%s\")\n", buffer);

 system(buffer);
}
