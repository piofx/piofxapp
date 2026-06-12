//when the webpage is loaded

jQuery(document).ready(function() {
    var quotes = new Array(
"<div class='errorpagecard'><p class ='errorpageword'>Orotund:</p> <p class='errorpagemeaning'>sonorous, or pompous</p></div>",
"<div class='errorpagecard'><p class ='errorpageword'>Rigmarole (also rigamarole):</p><p class='errorpagemeaning'>confused talk; complicated procedure</p></div>",
"<div class='errorpagecard'><p class ='errorpageword'>Squelch:</p> <p class='errorpagemeaning'>to suppress or silence; act of silencing; sucking sound</p></div>",
"<div class='errorpagecard'><p class ='errorpageword'>Obloquy:</p> <p class='errorpagemeaning'>condemning or abusive language, or the state of being subject to such</p></div>",
"<div class='errorpagecard'><p class ='errorpageword'>Adamant</p> <p class='errorpagemeaning'>Stubborn. Willful. Remember, the character Wolverine has a skeleton of Adamantium</p></div>",
"<div class='errorpagecard'><p class ='errorpageword'>Multifarious</p> <p class='errorpagemeaning'>Of various types. <br><b>Sentence:</b><br>The event contained multifarious activities</p></div>",
"<div class='errorpagecard'><p class ='errorpageword'>Piquant</p> <p class='errorpagemeaning'>Having a pleasantly sharp taste or appetizing flavour. Remember the delicious, and spicy pani puris. They could be described as piquant</p></div>",
"<div class='errorpagecard'><p class ='errorpageword'>Trenchant</p> <p class='errorpagemeaning'>Vigorous or strongly worded in expression or style. My teacher's trenchant comments discourage us from asking her doubts. She is not like Teju who is always soothing</p></div>",
"<div class='errorpagecard'><p class ='errorpageword'>Anachronistic</p> <p class='errorpagemeaning'>This is a nice word. It means something that is old-fashioned and a little out of place. Like an old rotary dial phone sitting beside a sleek new mobile phone.</p></div>",
"<div class='errorpagecard'><p class ='errorpageword'>Hedonist</p> <p class='errorpagemeaning'>Some one who believes seeking pleasure is the most important thing in life. [Psst... secretly, we are all hedonists, aren't we? We just don't admit it. ;)]. Sybarite is another synonym of the word.</p></div>",
"<div class='errorpagecard'><p class ='errorpageword'>Philanderer</p> <p class='errorpagemeaning'>A womaniser. A philanderer is a person who seeks women for pleasure. A casanova is someone who enjoys giving pleasure to women. While both of them are characterised by having many women, philanderer is more often used with a negative suggestion unlike the word casanova.</p></div>",
"<div class='errorpagecard'><p class ='errorpageword'>Maudlin</p> <p class='errorpagemeaning'>Excessively Sentimental. Prone to self pity. What happens to us when we are going through a break-up. :P We keep wondering why this has happened to us and how we feel that the world has done us great injustice. Example: No point being maudlin, man-up and find yourself a new partner!</p></div>",
"<div class='errorpagecard'><p class ='errorpageword'>Egregious</p> <p class='errorpagemeaning'>Something that is egregious stands out, in a bad way. It means really bad or offensive </p></div>",
"<div class='errorpagecard'><p class ='errorpageword'>Phlistine</p> <p class='errorpagemeaning'>A philistine is a person who doesn’t think a lot and isn't interested in learning. </p><p>Someone who's only interested in eating, sleeping, and watching TV, could be considered a philistine.</p></div>",
"<div class='errorpagecard'><p class ='errorpageword'>Apathetic</p> <p class='errorpagemeaning'>Apathetic is an adjective that describes the feeling of being bored with what’s going on around you. If you don’t care one way or another, you’re apathetic.</p></div>",
"<div class='errorpagecard'><p class ='errorpageword'>Aversion</p> <p class='errorpagemeaning'>If you have an aversion to something, you have an intense dislike for it. Commonly it's food, but you could have an aversion to learning, coming on time, or telling the truth.</p></div>",
"<div class='errorpagecard'><p class ='errorpageword'>Bewildered</p> <p class='errorpagemeaning'>If a conversation about something leaves you feeling bewildered, it means you are lost and befuddled. It is something baffling and confusing.</p></div>",
"<div class='errorpagecard'><p class ='errorpageword'>Buoyant</p> <p class='errorpagemeaning'>Something that is buoyant floats in water. Since floating is happier than sinking, buoyant also refers to things are fun and upbeat.</p></div>",
"<div class='errorpagecard'><p class ='errorpageword'>Cantankerous</p> <p class='errorpagemeaning'>If someone is cantankerous they are difficult to deal with. They are quarrelsome and unwilling to cooperate.</p></div>",
"<div class='errorpagecard'><p class ='errorpageword'>Crestfallen</p> <p class='errorpagemeaning'>If you are crestfallen, you are dark, depressed, and down in the dumps. You are in need of a hug.</p></div>",
"<div class='errorpagecard'><p class ='errorpageword'>Disconsolate</p> <p class='errorpagemeaning'>If you are sad and can't be cheered up, you're disconsolate. You are sad beyond comforting and incapable of being consoled </p></div>",
"<div class='errorpagecard'><p class ='errorpageword'>Distraught</p> <p class='errorpagemeaning'>If you are upset, you are distraught. You're deeply agitated from emotion. As if the pain from the whole world settled on your soul.</p></div>",
"<div class='errorpagecard'><p class ='errorpageword'>Sarcastic</p> <p class='errorpagemeaning'>Sarcastic humor mocks or ridicules, usually by saying the opposite of what is actually meant.</p></div>",
"<div class='errorpagecard'><p class ='errorpageword'>Tip for IELTS</p> <p class='errorpagemeaning'>Always focus on the words you know rather than on learning new words. It always helps!</p></div>"
);


    var randno = Math.floor(Math.random()*(quotes.length));
    jQuery('div.quote').append(quotes[randno]);
});