#include <stdlib.h>
#include <stdlib.h>
#include <unistd.h>
#include <string.h>
#include <sys/types.h>
#include <stdio.h>

int main(int argc, char **argv, char **envp)
{
 setuid(1003);
 setgid(1003);
 system("/usr/bin/env echo and now what?");
}
