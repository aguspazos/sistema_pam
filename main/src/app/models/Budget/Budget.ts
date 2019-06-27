import { User, StateChange, CutState, BoundsState } from "..";
import { LaminatedState } from "../LaminatedState/LaminatedState";
import { RumblingState } from "../RumblingState/RumblingState";
import { UvState } from "../UvState/UvState";
import { Client } from "../Client/Client";

export class Budget {
  id?: number;
  print_type_id?: number;
  paper_size?: string;
  paper_type?: string;
  prints_amount?: number;
  image_url?: string;
  notes?: string;
  updated_on?: Date;
  due_date?: Date;
  current_work_status_id?: number;
  current_status_type_id?: number;

  cut?: CutState;
  laminated?: LaminatedState;
  rumbled?: RumblingState;
  bound?: BoundsState;
  stateChanges?: StateChange[];
  uv?: UvState;
  client?: Client;
}
