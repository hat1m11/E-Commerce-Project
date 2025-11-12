/*******************************
 * Tester: Rohan Bhupla
 * University ID: 240147194
 * Function: This function tests the Minimum function implemented by Rohan.
 */

public class Rohan_Test {
    public static void main(String[] args) {
        Math math = new Math();

        // Test 1: 5 < 10
        int result1 = math.min(5, 10);
        if (result1 == 5) {
            System.out.println("Test Passed: min(5, 10) returned 5");
        } else {
            System.out.println("Test Failed: min(5, 10) returned " + result1);
        }
