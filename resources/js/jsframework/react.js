function calcButton(props) {
    return (
        <button>

        </button>
    );
}

class calcBoard extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            
        }
    }



    renderCalcButton(i) {
        return (
            <calcButton 
                value={i}
            />
        )
    }
}

class calcMain extends React.Component {

}