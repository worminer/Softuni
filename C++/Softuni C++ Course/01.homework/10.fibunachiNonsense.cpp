#include<iostream>

using namespace std;
unsigned long long first = 0, second = 1, next = 1, result = 1;
int n;
int fibunachiNoLoopSooItsRecursionThen(int n){
    if (n > 0){

        next = first + second;
        first = second;
        second = next;
        //cout << next << endl;
        result = next;
        fibunachiNoLoopSooItsRecursionThen(n-1);
    }
}

main()
{
    cout << "Because there there are 2 types and it is not sayed wich one is needed\n I am going for the clasical fibunach for more info see wikipedia \n " << endl;
    cout << "Clasical: 1,1,2,3,5,8,13,21,34,55,89,144,233,377,610,987,1597,2584,4181,6765.. and so on.." << endl;
    cout << "Enter the fibunachi number you want :" << endl;
    cin >> n;

    if (n == 1){
        result = 1;
    }else {
        fibunachiNoLoopSooItsRecursionThen(n-1);
    }
    //fibunachiNoLoopSooItsRecursionThen(n);
    cout << n <<"th fibunachi number is: " << result << endl;
    return 0;
}
