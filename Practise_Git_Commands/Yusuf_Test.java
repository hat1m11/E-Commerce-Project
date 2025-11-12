public class Yusuf_Test {

    /********************************
     Tester: Mohammed Yusuf
     University ID: 240104887
     Function: This function tests the multiply() function created by Arifa.
    ********************************/

    public static void main(String[] args) {
        Math math = new Math();
        
        // Single test: multiplying 3 and 4
        int result = math.multiply(3, 4);
        if (result == 12) {
            System.out.println("Test passed: multiply(3, 4) returned 12");
        } else {
            System.out.println("Test failed: multiply(3, 4) returned " + result);
        }
    }
}

