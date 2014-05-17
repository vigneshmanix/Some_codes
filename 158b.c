#include<stdio.h>
int main()
{
    int n,i,k,count1=0,count2=0,count3=0,cars=0;
    scanf("%d",&n);
    for(i=0;i<n;i++)
    {
        scanf("%d",&k);
        if(k==1)
            count1++;
        else if(k==2)
            count2++;
        else if(k==3)
            count3++;
        else if(k==4)
            cars++;
    }
    if(count3>count1)
    {
        cars=cars+count3;
        count3=0;
        count1=0;
    }
    else if(count3<count1)
    {
        cars=cars+count3;
        count1=count1-count3;
        count3=0;
    }
    else
    {
        cars=cars+count3;
        count3=0;
        count1=0;
    }
    cars=cars+(count2-(count2%2))/2+(count1-(count1%4))/4;
    count1=count1%4;
    count2=count2%2;
    if(count3<count1)
    {
        if((count1>2)&&(count2==1))
            cars=cars+2;
        else
            cars=cars+1;
    }
    else
    {
        cars=cars+count2;
    }
    printf("%d",cars);
    return 0;
}
