
function toggleFAQ(Num, Max=10) {
    for (i=1; i<=Max; i++) {
        if (i==Num)  {
            $('#f'+i).show();
            $('#fp'+i).hide(); 
            $('#fm'+i).show(); 
        }
        else {
            $('#f'+i).hide();
            $('#fp'+i).show(); 
            $('#fm'+i).hide(); 
        }
    }
}