#include <stdio.h>

int main(void) {
    double first, second;
    char operation;

    printf("Enter an expression (example: 8 * 2): ");
    if (scanf("%lf %c %lf", &first, &operation, &second) != 3) {
        printf("Invalid input.\\n");
        return 1;
    }

    switch (operation) {
        case '+': printf("Result: %.2f\\n", first + second); break;
        case '-': printf("Result: %.2f\\n", first - second); break;
        case '*': printf("Result: %.2f\\n", first * second); break;
        case '/':
            if (second == 0) printf("Cannot divide by zero.\\n");
            else printf("Result: %.2f\\n", first / second);
            break;
        default: printf("Unknown operator.\\n");
    }

    return 0;
}
