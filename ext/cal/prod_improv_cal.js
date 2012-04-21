function CalculateSum(Atext, Btext, Ctext, Dtext,form)
{
var hrs = parseFloat(Atext);
var rate = parseFloat(Btext);
var impro  = parseFloat(Ctext);
var drocost  = parseFloat(Dtext);
form.Answer.value = hrs * (impro/100);
form.Answer1.value = form.Answer.value * rate;
form.Answer2.value = drocost/form.Answer1.value;
}

/* ClearForm: this function has 1 argument: form.
   It clears the input and answer fields on the form. 
   It needs to know the names of the INPUT elements in order
   to do this. */

function ClearForm(form)
{
form.input_A.value = "";
form.input_B.value = "";
form.input_C.value = "";
form.input_D.value = "";
form.Answer.value = "";
form.Answer1.value = "";
form.Answer2.value = "";

}
