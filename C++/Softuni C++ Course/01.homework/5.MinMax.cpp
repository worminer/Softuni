#include <iostream>
using namespace std;

int main() {
    int n = 0,minNumber = 0,maxNumber = 0, currentNumber = 0;
    cout << "Specify number count: " << endl;
    cin >> n ;

    cin >> currentNumber;
    minNumber = maxNumber = currentNumber;
    for(int i = 0; i < n-1; i++){
        cin >> currentNumber;
        if (minNumber > currentNumber) {
            minNumber = currentNumber;
        }

        if (maxNumber < currentNumber) {
            maxNumber = currentNumber;
        }
    }
    cout << "Smallest number is:" << minNumber <<endl;
    cout << "Biggest  number is:" << maxNumber <<endl;
    return 0;
}

