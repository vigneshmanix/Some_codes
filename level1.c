#include <stdio.h>
#include <stdlib.h>
#include <sys/types.h>
#include <unistd.h>
int main(int argc, char **argv)
{
  

setuid(1002);
setgid(1002);
printf("Current time: ");
  fflush(stdout);
  system("/usr/bin/env date");

  return 0;
}
